angular.module('powerForm', [])
    .controller('PowerFormController', function($scope) {

        $scope.CONFIG = CONFIG;

        /**
         * Assign default values to the form
         *
         * @type {any[]}
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
        }
    });
