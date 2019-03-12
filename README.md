# Closum Connector plugin for Craft CMS 3.x

Connects contact form with Closum to save contacts.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require popperz0r/closum-connector

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Closum Connector.

## Closum Connector Overview

This plugin is used to integrate the contact form of your website with your account from Closum.com.
It follows Closum rest api documentation as it follows: https://developers.closum.com/

## Configuring Closum Connector

You are required to insert both `api_username` and `api_pw` in order to connect with your Closum account.
If you wish to be notified when you recieve a new contact you should enable `Send Email Notification` and fill `Email to be Notified`

## Using Closum Connector

After installing you will have two endpoints available.

1. To retrieve cities to populate your cities dropdown:

        http://yourwebsite.tld/actions/closum-connector/lead/get-cities

2. Then to post your form data via ajax or post:

         http://yourwebsite.tld/actions/closum-connector/lead/submit-lead


## Closum Connector Roadmap

Todo, and ideas for potential features:

* Create a base form as template

Brought to you by [popperz0r](https://twitter.com/popperz0r)
