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
     * Assign default values to the form
     *
     * @type {*[]}
     */
    $scope.resetValues = function() {
        $scope.values = CONFIG
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
     * Send the form
     */
    $scope.send = async () => {

        // prevent double submissions
        if ($scope.state === $scope.STATE_SENDING)
            return;

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
        $scope.state = $scope.STATE_SENT;
        $scope.$apply();
    };

    $scope.resetValues();
    $scope.$apply();
});
