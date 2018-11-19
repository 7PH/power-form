(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = y[op[0] & 2 ? "return" : op[0] ? "throw" : "next"]) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [0, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
Object.defineProperty(exports, "__esModule", { value: true });
var app = angular.module("powerForm", []);
app.controller("PowerFormController", function ($scope) {
    return __awaiter(this, void 0, void 0, function () {
        var _this = this;
        var CONFIG;
        return __generator(this, function (_a) {
            switch (_a.label) {
                case 0:
                    $scope.STATE_NOT_SENT = 0;
                    $scope.STATE_SENDING = 1;
                    $scope.STATE_SENT = 2;
                    $scope.state = $scope.STATE_NOT_SENT;
                    return [4, fetch('./app/server/config.php')];
                case 1: return [4, (_a.sent()).json()];
                case 2:
                    CONFIG = _a.sent();
                    $scope.CONFIG = CONFIG;
                    $scope.getDefaults = function () {
                        return CONFIG
                            .elements
                            .map(function (element) {
                            switch (element.type) {
                                case 'separator': return null;
                                case 'checkbox': return !!element.default;
                                default: return element.default || "";
                            }
                        });
                    };
                    $scope.resetValues = function () {
                        $scope.values = $scope.getDefaults();
                    };
                    $scope.formHasBeenTouched = function () {
                        var defaults = $scope.getDefaults();
                        return $scope
                            .values
                            .map(function (v, i) { return v !== defaults[i]; })
                            .reduce(function (old, curr) { return old || curr; }, false);
                    };
                    $scope.send = function () { return __awaiter(_this, void 0, void 0, function () {
                        var result, json;
                        return __generator(this, function (_a) {
                            switch (_a.label) {
                                case 0:
                                    if (!$scope.formHasBeenTouched()) {
                                        alert("Please fill the form before submitting");
                                        return [2, false];
                                    }
                                    if ($scope.state === $scope.STATE_SENDING) {
                                        return [2, false];
                                    }
                                    $scope.state = $scope.STATE_SENDING;
                                    return [4, fetch('./app/server/result.php', {
                                            method: 'POST',
                                            body: JSON.stringify($scope.values),
                                            headers: {
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json'
                                            }
                                        })];
                                case 1:
                                    result = _a.sent();
                                    $scope.resetValues();
                                    return [4, result.json()];
                                case 2:
                                    json = _a.sent();
                                    console.log("response", json);
                                    $scope.state = $scope.STATE_SENT;
                                    $scope.$apply();
                                    return [2];
                            }
                        });
                    }); };
                    $scope.resetValues();
                    $scope.$apply();
                    return [2];
            }
        });
    });
});

},{}]},{},[1])

//# sourceMappingURL=index.js.map
