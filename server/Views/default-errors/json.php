{
    "status": <?php echo $response->getStatusCode();?>,
    "description": "<?php echo $response->getReasonPhrase(); ?>",
    "message": "<?php if (!empty($message)) echo $message; else echo 'Sorry, something went wrong and we are working on it. Please try again later'; ?>"
}
