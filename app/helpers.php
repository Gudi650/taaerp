<?php

if (! function_exists('company_name')) {
    /**
     * Product / company display name from config/company.php
     */
    function company_name(): string
    {
        return (string) config('company.name');
    }
}

if (! function_exists('company_tagline')) {
    /**
     * Product tagline from config/company.php
     */
    function company_tagline(): string
    {
        return (string) config('company.tagline');
    }
}

