<?php

namespace AceLords\Core\Library;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use AceLords\Core\Repositories\RedisRepository;

class SiteConstants
{

    protected $repo, $data;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->repo = resolve(RedisRepository::class);

        $this->data = collect();

        $this->getTargetDomain();

        $this->getOrganisationDetails();

        $this->getTheme();

        $this->extra();

        $this->saveToSession();
    }

    /**
     * return an array to be shared to the views
     */
    public function data()
    {
        return $this->data->toArray();
    }

    /**
     * get the target domain details
     */
    public function getTargetDomain()
    {
        // get domain first.. from redis
        $domains = $this->repo->get('domains');

        if($domains) {
            $target = $domains->where('url', sanitizeDomainUrl(request()->url()))->first();

            if($target) {
                $this->data->put('site_domain', $target);
            }
        }
    }

    /**
     * get the organisation manenos
     */
    public function getOrganisationDetails()
    {
        // site details manenos
        if ($this->data->get('site_domain'))
        {
            $orgDetails = $this->repo->get('organisations')
                ->where('domain_id', $this->data->get('site_domain')->id)
                ->first();

            if ($orgDetails)
            {
                // append common org details
                collect((array)($orgDetails))
                    ->except(['id', 'domain_id', 'created_at', 'updated_at', 'deleted_at', 'social_profiles'])
                    ->each(function($item, $key) {
                        $this->data->put('site_' .$key, $item);
                    });

                // append social sites
                collect(json_decode(collect((array)($orgDetails))->get('social_profiles')))
                    ->each(function($item, $key) {
                        $this->data->put('site_' .$key, $item);
                    });

            } else {
                $this->setNotFoundOrganization();
            }
        } else {
            $this->setNotFoundOrganization();
        }
    }

    /**
     * Set the theme to be used in front-end
     */
    public function getTheme()
    {
        $targetTheme = env('ACELORDS_FRONTEND_THEME');

        if ($this->data->get('site_domain'))
        {
            $theme = $this->repo->get('themes')
                ->where('domain_id', $this->data->get('site_domain')->id)
                ->first();

            if ($theme)
            {
                $targetTheme = $theme->name;
            }
        }

        $this->data->put(config('acelords_core.site_theme_key'), $targetTheme);

        // feed current data into the session. No need to add other info
        session()->put(config('acelords_core.site_theme_key'), $targetTheme);
    }

    /**
     * Attach extra items
     */
    public function extra()
    {
        $configurations = $this->repo->get('configurations');

        if(! $configurations)
            $configurations = collect();

        $this->data->put('title_separator', $configurations->firstWhere('name', 'title_separator')->value ?? '-');
        $this->data->put('site_version', $configurations->firstWhere('name', 'site_version')->value ?? '-');
        $this->data->put('site_codename', $configurations->firstWhere('name', 'site_codename')->value ?? '-');
        $this->data->put('product_name', $configurations->firstWhere('name', 'product_name')->value ?? '-');
        $this->data->put('system_updates_endpoint', $configurations->firstWhere('name', 'system_updates_endpoint')->value ?? '-');
    }

    /**
     * set up some stuff in session
     */
    private function saveToSession()
    {
        session()->put('site_name', $this->data->get('site_name'));
        session()->put('site_email', $this->data->get('site_email'));
        session()->put('site_support_email', $this->data->get('site_support_email'));
        session()->put('site_no_reply_email', $this->data->get('site_no_reply_email'));
        session()->put('site_mobile', $this->data->get('site_mobile'));
        session()->put('site_telephone', $this->data->get('site_telephone'));
        session()->put('site_theme_color', $this->data->get('site_theme_color'));
        session()->put('site_version', $this->data->get('site_version'));
        session()->put('site_codename', $this->data->get('site_codename'));
        session()->put('product_name', $this->data->get('product_name'));
    }

    /**
     * Pre-fill entries if entries are not yet set
     */
    private function setNotFoundOrganization()
    {
        return [
            'site_name', env('APP_NAME'),
            'site_email', null,
            'site_support_email', null,
            'site_no_reply_email', null,
            'site_mobile', null,
            'site_telephone', null,
            'site_theme_color', null,
            'site_version', env('APP_VERSION'),
            'site_codename', null,
            'product_name', null,
        ]
    }

}