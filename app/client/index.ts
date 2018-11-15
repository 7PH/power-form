import {Config} from "./config/Config";

// @ts-ignore
const app = angular.module("powerForm", []);

app.controller("PowerFormController", async function ($scope: any) {

    /**
     * Load config
     */
    const CONFIG: Config = await (await fetch('./config.json')).json();
    $scope.CONFIG = CONFIG;

    /**
     * Assign default values to the form
     *
     * @type {*[]}
     */
    $scope.values = CONFIG
        .elements
        .map((element: any) => {
            switch (element.type) {
                case 'separator': return null;
                case 'checkbox': return !! element.default;
                default: return element.default;
            }
        });

    /**
     * Send the form
     */
    $scope.send = () => {
        alert(JSON.stringify($scope.values));
    };

    $scope.$apply();
});
