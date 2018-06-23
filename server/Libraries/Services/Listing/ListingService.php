<?php
namespace ParkAlong\Libraries\Services\Listing;

use \Illuminate\Database\MySqlConnection;
use ParkAlong\Libraries\ORM;
use \Illuminate\Database\Eloquent\MassAssignmentException;
use ParkAlong\Libraries\Payment\Stripe;
use \Psr\Log\LoggerInterface;

/**
 * Profile Service
 *
 * This is an implementation that only works with matching environments.
 *
 * @author Marco A Chang marco@parkalong.us
 * @version 0.2
 * @since 4/2/2016
 */
class ListingService implements Interfaces\ListingServiceInterface
{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATUDAY = 6;
    const SUNDAY = 7;

    protected $db;

    public function __construct(MySqlConnection $db, Stripe $stripe, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->stripe = $stripe;
        $this->logger = $logger;
    }

    /*public function bookSpace($spaceId, $userId, array $details)
    {
        $token = 'sk_test_jyq82ugrH1hTcfkFKUZ56O1v';

        $user = ORM\Profile::with('user')->where('user_id', '=', $userId)->first();

        $this->db->table('spaces')
            ->select('spaces.')
    }*/

    public function getSpaces($listingId)
    {
        $listing = $this->db->select($this->db->raw(
            'SELECT `listings`.`id`, `listing_types`.`type`, JSON_UNQUOTE(`listings`.`data`->"$.business_name") as `business_name`, JSON_UNQUOTE(`listings`.`data`->"$.msu_miles") as `msu_miles`, JSON_UNQUOTE(`data`->"$.address")  as `address`, JSON_UNQUOTE(`data`->"$.img") as `img`, `listings`.`description`
                FROM `listings`
                JOIN `listing_types`
                    ON `listing_types`.`id` = `listings`.`listing_type_id`
                WHERE
                    `listings`.`id` = :listingId
                    AND `listings`.`active` = 1'
        ), ['listingId' => $listingId]);

        if (empty($listing)) {
            return null;
        }

        $listing = $listing[0];

        $spaces =  $this->db->select($this->db->raw(
            'SELECT `spaces`.`id`, `spaces`.`full`, `spaces`.`space_ref`, `spaces`.`hourly`, `spaces`.`daily`, `spaces`.`monthly`, `spaces`.`yearly`, `spaces`.`hourly_price`, `spaces`.`daily_price`, `spaces`.`monthly_price`, `spaces`.`yearly_price`, `spaces`.`vehicle_size_id`, `spaces`.`days`, `spaces`.`hours`, `spaces`.`summary`
                FROM `spaces`
                WHERE
                    `spaces`.`listing_id` = :listingId
                    AND `spaces`.`full` = 0'
        ), ['listingId' => $listingId]);

        if (empty($spaces)) {
            return null;
        }

        for ($i = 0; $i < count($spaces); $i++) {
            $spaces[$i]['days'] = json_decode($spaces[$i]['days'], true);
            $spaces[$i]['hours'] = json_decode($spaces[$i]['hours'], true);
            $spaces[$i]['summary'] = json_decode($spaces[$i]['summary'], true);
        }

        $listing['spaces'] = $spaces;

        return $listing;
    }

    public function getAvailableSpaces($listingId, $type, $startTime, $endTime)
    {
        $select = 'SELECT `spaces`.`id`, `spaces`.`quantity`, `spaces`.`space_ref`, `spaces`.`hourly`, `spaces`.`daily`, `spaces`.`monthly`, `spaces`.`yearly`, `spaces`.`hourly_price`, `spaces`.`daily_price`, `spaces`.`monthly_price`, `spaces`.`yearly_price`, `spaces`.`vehicle_size_id`, `spaces`.`days`, `spaces`.`hours`, `spaces`.`summary`
            FROM `spaces`
            WHERE
                `spaces`.`listing_id` = :listingId';

        $hourly = ' AND `spaces`.`hourly` = 1';

        $daily = ' AND `spaces`.`daily` = 1';

        $monthly = ' AND `spaces`.`monthly` = 1';

        $yearly = ' AND `spaces`.`yearly` = 1';

        $days = ' AND JSON_CONTAINS(spaces.days, JSON_ARRAY(%s))';

        $dayHour = ' AND JSON_CONTAINS(spaces.hours, JSON_OBJECT(%s, JSON_ARRAY(%s)))';

        $timestamp = ' AND FROM_UNIXTIME(:startTime) BETWEEN bookings.start_time AND bookings.end_time
        AND FROM_UNIXTIME(:endTime) BETWEEN bookings.start_time AND bookings.end_time';

        switch ($type) {
            case 'hourly':
                $query = $select;

                $query .= $hourly;

                $schedule = $this->getSchedule($startTime, $endTime);

                $query .= sprintf($days, implode(',', array_keys($schedule)));

                foreach ($schedule as $day => $times) {
                    $query .= sprintf($dayHour, $day, implode(',', $times));
                }

                //$query .= $timestamp;

                $spaces = $this->db->select($this->db->raw($query), [
                    'listingId' => $listingId
                ]);
                break;
            case 'daily':
                break;
            case 'monthly':
                $query = $select;

                $query .= $monthly;

                //$query .= $timestamp;

                $spaces = $this->db->select($this->db->raw($query), [
                    'listingId' => $listingId
                ]);
                break;
            case 'yearly':
                break;
        }

        if (empty($spaces)) {
            return null;
        }

        $bookedSql = "SELECT COUNT(*) as total
            FROM `bookings`
            WHERE
                `bookings`.`space_id` IN (%s)
                AND FROM_UNIXTIME(:startTime) BETWEEN bookings.start_time AND bookings.end_time = 1
                AND FROM_UNIXTIME(:endTime) BETWEEN bookings.start_time AND bookings.end_time = 1";

        $booked = $this->db->select($this->db->raw(
            sprintf($bookedSql, implode(',', array_column($spaces, 'id')))
        ), [
            'startTime' => $startTime,
            'endTime' => $endTime
        ]);

        if (!empty($booked) && $booked[0]['total'] >= $spaces[0]['quantity']) {
            return null;
        }

        return $spaces;
    }

    public function bookSpace($userId, $listingId, $spaceId, $type, $startTime, $endTime)
    {
        $this->logger->debug('Booking process started');

        $this->logger->debug(json_encode([
            'userId' => $userId,
            'listingId' => $listingId,
            'spaceId' => $spaceId,
            'type' => $type,
            'startTime' => $startTime,
            'endTime' => $endTime
        ]));

        $user = $this->db->select($this->db->raw(
            'SELECT JSON_UNQUOTE(profiles.info->"$.payment.stripe_account_token") as account_id, users.email
            FROM profiles
            JOIN users
                ON users.id = profiles.user_id
            WHERE profiles.user_id = :userId'
        ), [
            'userId' => $userId
        ]);

        $user = $user[0];

        $select = 'SELECT `spaces`.`id`, `spaces`.`quantity`,  `spaces`.`hourly_price`, `spaces`.`daily_price`, `spaces`.`monthly_price`, `spaces`.`yearly_price`, `spaces`.`days`, `spaces`.`hours`
            FROM `spaces`
            WHERE
                `spaces`.`id` = :spaceId
                AND `spaces`.`listing_id` = :listingId';

        $hourly = ' AND `spaces`.`hourly` = 1';

        $daily = ' AND `spaces`.`daily` = 1';

        $monthly = ' AND `spaces`.`monthly` = 1';

        $yearly = ' AND `spaces`.`yearly` = 1';

        $days = ' AND JSON_CONTAINS(spaces.days, JSON_ARRAY(%s))';

        $dayHour = ' AND JSON_CONTAINS(spaces.hours, JSON_OBJECT(%s, JSON_ARRAY(%s)))';

        $query = $select;

        switch ($type) {
            case 'hourly':
                $query .= $hourly;

                $schedule = $this->getSchedule($startTime, $endTime);

                $query .= sprintf($days, implode(',', array_keys($schedule)));

                foreach ($schedule as $day => $times) {
                    $query .= sprintf($dayHour, $day, implode(',', $times));
                }

                break;
            case 'daily':
                $query .= $daily;

                break;
            case 'monthly':
                $query .= $monthly;

                break;
            case 'yearly':
                $query .= $yearly;

                break;
        }

        $this->logger->debug($query);

        $space = $this->db->select($this->db->raw($query), [
            'spaceId' => $spaceId,
            'listingId' => $listingId
        ]);

        if (empty($space)) {
            throw new Exceptions\SpaceRequirementException('Space does not meet the time requirements provided');
        }

        $space = $space[0];

        $timezone = new \DateTimeZone('UTC');
        $startTime = new \DateTime($startTime, $timezone);
        $endTime = new \DateTime($endTime, $timezone);

        $bookedSql = "SELECT COUNT(*) as total
            FROM `bookings`
            WHERE
                `bookings`.`space_id` = :spaceId
                AND :startTime BETWEEN bookings.start_time AND bookings.end_time = 1
                OR :endTime BETWEEN bookings.start_time AND bookings.end_time = 1
                OR bookings.start_time BETWEEN :rangeStart1 AND :rangeEnd1 = 1
                OR bookings.end_time BETWEEN :rangeStart2 AND :rangeEnd2 = 1";

        $this->logger->debug($bookedSql);
        $this->logger->debug('Start ' . $startTime->format('Y-m-d H:i:s'));
        $this->logger->debug('End ' . $endTime->format('Y-m-d H:i:s'));

        $booked = $this->db->select($this->db->raw($bookedSql), [
            'spaceId' => $space['id'],
            'startTime' => $startTime->format('Y-m-d H:i:s'),
            'endTime' => $endTime->format('Y-m-d H:i:s'),
            'rangeStart1' => $startTime->format('Y-m-d H:i:s'),
            'rangeEnd1' => $endTime->format('Y-m-d H:i:s'),
            'rangeStart2' => $startTime->format('Y-m-d H:i:s'),
            'rangeEnd2' => $endTime->format('Y-m-d H:i:s')
        ]);

        $this->logger->debug("Total spaces: {$space['quantity']}");
        $this->logger->debug("Total booked: {$booked[0]['total']}");

        if (!empty($booked) && ($booked[0]['total'] >= $space['quantity'])) {
            throw new Exceptions\NotAvailableException('Space is full');
        }

        /*$date = new \DateTime();
        $date->setTimeZone(new \DateTimeZone('UTC'));

        $startDateTime = $date->setTimestamp($startTime);

        $temp = clone $date;
        $endDateTime = $temp->setTimestamp($endTime);

        $diff = $endDateTime->diff($startDateTime);*/

        switch ($type) {
            case 'hourly':
                $hourlyDiff = ($endTime->getTimestamp() - $startTime->getTimestamp())/3600;
                $this->logger->debug("Calculating hourly rate: Base({$space['hourly_price']}) * Hours({$hourlyDiff})");
                //$amount = ($space['hourly_price'] * $diff->h);
                $amount = $space['hourly_price'] * $hourlyDiff;
                break;
            case 'daily':
                $amount = $space['daily_price'];
                break;
            case 'monthly':
                $amount = $space['monthly_price'];
                break;
            case 'yearly':
                $amount = $space['yearly_price'];
                break;
        }

       $this->db->beginTransaction();

        try {
            $supplier = $this->db->table('listings')
            ->select('listings.user_id as id')
            ->where('listings.id', '=', $listingId)
            ->first();

            $vehicle = $this->db->table('vehicles')
                ->select('id')
                ->where('vehicles.user_id', '=', $userId)
                ->first();

            $bookingId = $this->db->table('bookings')->insertGetId([
                'supplier_id' => $supplier['id'],
                'driver_id' => $userId,
                'space_id' => $spaceId,
                'vehicle_id' => $vehicle['id'],
                'start_time' => $startTime->format('Y-m-d H:i:s'),
                'end_time' => $endTime->format('Y-m-d H:i:s'),
                'type' => $type,
                'amount' => $amount
            ]);

            $transactionId = $this->db->table('transactions')->insertGetId([
                'booking_id' => $bookingId,
                'supplier_id' => $supplier['id'],
                'driver_id' => $userId,
                'space_id' => $spaceId,
                'processor' => 'stripe',
                'currency' => 'usd',
                'amount_no_tax' => $amount,
                'amount' => $amount,
                'tax' => 0,
                'type' => $type,
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);

            // times 100 because stripe wants cents
            if (!$confirmation = $this->stripe->charge($user['account_id'], $user['email'], $amount * 100)) {
                $this->logger->debug(json_encode($confirmation));
                throw new Exceptions\BookingDeclinedException('Unable to charge card');
            }

            $this->db->table('transactions')
                ->where('id', '=', $transactionId)
                ->update(['confirmation' => $confirmation]);
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
            $this->db->rollBack();
            throw $e;
        }

        $this->db->commit();

        return true;
    }

    // location, time, day
    public function getListings(array $data)
    {
        if (empty($data['start'])) {
            return $this->db->select($this->db->raw(
               'SELECT `listings`.`id`, `listing_types`.`type`, JSON_UNQUOTE(`listings`.`data`->"$.business_name") as `business_name`, JSON_UNQUOTE(`listings`.`data`->"$.msu_miles") as `msu_miles`, JSON_UNQUOTE(`data`->"$.address") as `address`, `spaces`.`parking_price` as `price`, `listings`.`description`
                FROM `listings`
                JOIN `listing_types`
                    ON `listing_types`.`id` = `listings`.`listing_type_id`
                JOIN `spaces`
                    ON `spaces`.`listing_id` = `listings`.`id`
                WHERE
                    `listings`.`active` = 1'
            ));
        } else {
            $listings = $this->db->select($this->db->raw(
               'SELECT `listings`.`id`, `listings`.`listing_type_id`, JSON_UNQUOTE(`listings`.`data`->"$.business_name") as `business_name`, JSON_UNQUOTE(`listings`.`data`->"$.msu_miles") as `msu_miles`, JSON_UNQUOTE(`listings`.`data`->"$.address") as `address`, `listings`.`description`
                FROM `listings`'
            ));

            $query = "SELECT `listing_id`, MAX(`parking_price`) as `price`
                FROM `spaces`
                WHERE
                (`spaces`.`active`, `spaces`.`full`, `spaces`.`listing_id`) ";

            $in = [];

            foreach ($listings as $listing) {
                //$data[$listing['id']] = $listing;
                $in[] = "(1, 0, {$listing['id']})";
            }

            if (count($in) > 1) {
                $query .= "IN (" . implode(',', $in) . ")";
            } else {
                $query .= "= {$in[0]}";
            }

            $jsonClause = " AND JSON_CONTAINS(`spaces`.`availability`, JSON_OBJECT(%d, JSON_ARRAY(%s))) = 1";

            foreach ($this->getSchedule($data['start'], $data['end']) as $day => $times) {
                $query .= sprintf($jsonClause, $day, implode(',', $times));
            }

            $query .= " GROUP BY `spaces`.`listing_id`";

            $matches = $this->db->select($this->db->raw($query));

            if (empty($matches)) {
                return null;
            }

            $matchIds = array_intersect(
                array_column($listings, 'id'),
                array_column($matches, 'listing_id')
            );

            $result = [];

            foreach ($matchIds as $pos => $id) {
                $listing[$pos]['price'] =
                $result[] = $listings[$pos];
            }

            return $result;
        }
    }

    // location, time, day
    public function getListingSpaces($listingId) {
        if (empty($data['start'])) {
            $listings = $this->db->select($this->db->raw(
               'SELECT `vehicle_sizes`.`size`, `spaces`.`parking_price`, `spaces`.`availability`
                FROM `spaces`
                JOIN `vehicle_sizes`
                    ON `vehicle_sizes`.`id` = `spaces`.`vehicle_size_id`
                WHERE
                    `spaces`.`listing_id` = 1
                    AND `spaces`.`active` = 1'
            ));
        } else {
            $this->getSchedule($start, $end);
        }
    }

    //timestamp-> day, time slots
    protected function getSchedule($start, $end)
    {
        $timezone = new \DateTimeZone('UTC');
        $startDateTime = new \DateTime($start, $timezone);
        $endDateTime = new \DateTime($end, $timezone);

        /*$date = new \DateTime();
        $date->setTimeZone(new \DateTimeZone('UTC'));

        $startDateTime = $date->setTimestamp($start);

        $temp = clone $date;
        $endDateTime = $temp->setTimestamp($end);*/
        //die(var_dump($startDateTime->format('Y-m-d H:i:s'), $endDateTime->format('Y-m-d H:i:s')));
        $schedule = [];

        $startDay = $startDateTime->format('N');
        $endDay = $endDateTime->format('N');

        if ($startDay === $endDay) {
            $schedule[$startDay] = $this->getTimeSlots($startDateTime, $endDateTime);
        } else {
            $schedule[$startDay] = $this->getTimeSlots($startDateTime, null);
            $schedule[$endDay] = $this->getTimeSlots(null, $endDateTime);
        }

        return $schedule;
    }

    /*2 hours is 2 hours * (1 hour/ 1 hour) = 2 hours
45 minutes is 45 minutes * (1 hour / 60 minutes) = 45/60 hours = 0.75 hours
45 seconds is 45 seconds * (1 hour / 3600 seconds) = 45/3600 hours = 0.0125 hours
Adding them all together we have 2 hours + 0.75 hours + 0.0125 hours = 2.7625 hours*/

    protected function getTimeSlots(\DateTime $start = null, \DateTime $end = null)
    {
        $times = [];
        $startBound = empty($start) ? $start : $this->getHours($start);
        $endBound = empty($end) ? $end : $this->getHours($end);

        if (empty($startBound)) {
            for ($t = 0; $t <= $endBound; $t += 0.25) {
                $times[] = $t;
            }
        } elseif (empty($endBound)) {
             for ($t = $startBound; $t <= 23.75; $t += 0.25) {
                $times[] = $t;
            }
        } else {
            for ($t = $startBound; $t <= $endBound; $t += 0.25) {
                $times[] = $t;
            }
        }

        return $times;
    }

    protected function getHours(\DateTime $dateTime) {
        return $dateTime->format('G') + (intval($dateTime->format('i')) / 60);
    }

    public function getListingDetails($userId, $listingId)
    {

    }
}
