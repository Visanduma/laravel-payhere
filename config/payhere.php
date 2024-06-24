<?php

/*
 * PayHere full api guide is available here https://support.payhere.lk/api-&-mobile-sdk
 *
 * */

return [

    /*
     PayHere api url. usually,
     for production   https://www.payhere.lk
     for testing  https://sandbox.payhere.lk
      remember to update api when production
     * */

    'api_endpoint' => env('PAYHERE_API'),

    /*
      PayHere merchant ID can be found in their dashboard
      https://www.payhere.lk/account/settings/domain-credentials
     * */

    'merchant_id' => env('PAYHERE_MERCHANT_ID'),

    /*
     Merchant Secret is specific to each App/Domain. it can be generated for your domain/app as follows
     https://www.payhere.lk/account/settings/domain-credentials
        *Click 'Add Domain/App' > Fill details > Click 'Request to Allow'
        *Wait for the approval for your domain
        *Copy the Merchant Secret for your domain/app to .env file
     * */
    'merchant_secret' => env('PAYHERE_MERCHANT_SECRET'),

    /*
     Follow PayHere official instructions to obtain 'app_id' and 'app_secret'.
     NOTE: you don't need to generate "Authorization code". it will be automatically generate by this package
        *Sign in to your PayHere account & go to Settings > Business Apps section
        *Click 'Create App' button & enter an app name & comma separated domains to whitelist
        *Tick the permission 'Payment Retrieval API'
        *Click 'Add Business App' button to create the app
        *Once the app is created click 'View Credential' button in front of the created app
        *Copy the 'App ID' & 'App Secret' values
     * */
    'app_id' => env('PAYHERE_APP_ID'),
    'app_secret' => env('PAYHERE_APP_SECRET'),

];
