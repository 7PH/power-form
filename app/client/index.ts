import {Config} from "./Config";


// @ts-ignore
const app = angular.module("powerForm", []);

app.controller("PowerFormController", async function ($scope: any) {

    /**
     * State
     */
    $scope.STATE_NOT_SENT = 0;
    $scope.STATE_SENDING = 1;
    $scope.STATE_SENT = 2;
    $scope.state = $scope.STATE_NOT_SENT;

    /**
     * Load config
     */
    const CONFIG: Config = await (await fetch('./app/server/config.php')).json();
    $scope.CONFIG = CONFIG;

    /**
     *
     */
    $scope.getDefaults = function() {
        return CONFIG
            .elements
            .map((element: any) => {
                switch (element.type) {
                    case 'separator': return null;
                    case 'checkbox': return !! element.default;
                    default: return element.default || "";
                }
            });
    };

    /**
     * Assign default values to the form
     *
     * @type {*[]}
     */
    $scope.resetValues = function() {
        $scope.values = $scope.getDefaults();
    };

    /**
     *
     * @returns {boolean}
     */
    $scope.formHasBeenTouched = function() {

        const defaults = $scope.getDefaults();

        return $scope
            .values
            .map((v: any, i: number) => v !== defaults[i])
            .reduce((old: boolean, curr: boolean) => old || curr, false);
    };

    /**
     * Send the form
     */
    $scope.send = async () => {

        if (! $scope.formHasBeenTouched()) {
            alert("Please fill the form before submitting");
            return false;
        }

        // prevent double submissions
        if ($scope.state === $scope.STATE_SENDING) {
            return false;
        }

        $scope.state = $scope.STATE_SENDING;
        const result: Response = await fetch('./app/server/result.php', {
            method: 'POST',
            body: JSON.stringify($scope.values),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        $scope.resetValues();

        const json: any = await result.json();

        console.log("response", json);
        if (typeof (<any>window)["onFormSent"] === "function")
            (<any>window)["onFormSent"]();
        $scope.state = $scope.STATE_SENT;
        $scope.$apply();
    };

    $scope.resetValues();
    $scope.$apply();
});
