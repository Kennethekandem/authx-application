<?php
/**
 * Created by IntelliJ IDEA.
 * User: psalm29
 * Date: 20/09/2017
 * Time: 9:01 PM
 */

class config {

    public static function base() {

        if(config::production()) {
            return 'https://authxapp.com';
        }else {
            return 'http://authxapp.test';
        }

    }

    public static function production() {
        return false;
    }

    public static function email() {
        return '';
    }

    public static function name() {
        return "AuthX Application";
    }


    public static function phone() {
        return "";
    }

    public static function address() {
        return "";
    }

    public static function description() {
        return "";
    }

    public static function url() {
        return self::base();
    }

    public static function og_logo() {
        return 'assets/images/logo.png';
    }

    public static function meta() {
        ?>
        <!-- Search Engine -->
        <meta name="description" content="<?php echo self::description(); ?>">
        <meta name="image" content="<?php echo self::base().self::logo(); ?>">

        <!-- Schema.org for Google -->
        <meta itemprop="name" content="<?php echo self::name(); ?>">
        <meta itemprop="description" content="<?php echo self::description(); ?>">
        <meta itemprop="image" content="<?php echo self::base().self::logo(); ?>">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo self::name(); ?>">
        <meta name="twitter:description" content="<?php echo self::description(); ?>">

        <!-- Open Graph general (Facebook, Pinterest & Google+) -->
        <meta name="og:title" content="<?php echo self::name(); ?>">
        <meta name="og:description" content="<?php echo self::description(); ?>">
        <meta name="og:image" content="<?php echo self::base().self::og_logo(); ?>">
        <meta name="og:url" content="<?php echo self::base(); ?>">
        <meta name="og:site_name" content="<?php echo self::name(); ?>">
        <meta name="og:type" content="website">

        <?php
    }
}
