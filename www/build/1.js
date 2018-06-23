webpackJsonp([1],{

/***/ 268:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoginPageModule", function() { return LoginPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(98);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__login__ = __webpack_require__(270);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var LoginPageModule = /** @class */ (function () {
    function LoginPageModule() {
    }
    LoginPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["I" /* NgModule */])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__login__["a" /* LoginPage */]
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["d" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__login__["a" /* LoginPage */])
            ],
            exports: [
                __WEBPACK_IMPORTED_MODULE_2__login__["a" /* LoginPage */]
            ],
            providers: []
        })
    ], LoginPageModule);
    return LoginPageModule;
}());

//# sourceMappingURL=login.module.js.map

/***/ }),

/***/ 270:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LoginPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(98);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};


var LoginPage = /** @class */ (function () {
    function LoginPage(nav) {
        this.nav = nav;
    }
    LoginPage.prototype.login = function (citizen) {
        this.nav.push('ProfilePage', {});
    };
    LoginPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["m" /* Component */])({template:/*ion-inline-start:"C:\Users\marcochang\woofup\src\pages\login\login.html"*/'\n\n<ion-content class="login" padding>\n\n\n\n    \n\n\n\n    <img src="../assets/imgs/logo.png" />\n\n    <h2>Woofup</h2>\n\n    <p> Woofup is a dog meet up community that helps building dogs’ long-term friendships.</p>\n\n\n\n\n\n\n\n\n\n    <button ion-button color="primary" (click)="login()">Login</button>\n\n\n\n</ion-content>\n\n\n\n\n\n'/*ion-inline-end:"C:\Users\marcochang\woofup\src\pages\login\login.html"*/
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["e" /* NavController */]])
    ], LoginPage);
    return LoginPage;
}());

//# sourceMappingURL=login.js.map

/***/ })

});
//# sourceMappingURL=1.js.map