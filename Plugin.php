<?php namespace Zoomyboy\Osm;

use Backend;
use System\Classes\PluginBase;
use Zoomyboy\Osm\FormWidgets\Location;
use Zoomyboy\Osm\Classes\Nominatim;
use GuzzleHttp\Client;

/**
 * osm Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'osm',
            'description' => 'No description provided yet...',
            'author'      => 'zoomyboy',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(Nominatim::class, function() {
            $client = new Client(['base_uri' => 'https://nominatim.openstreetmap.org']);
            return new Nominatim($client);
        });
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Zoomyboy\Osm\Components\OsmMap' => 'zoomyboy_osm_map',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'zoomyboy.osm.all' => [
                'tab' => 'osm',
                'label' => 'OSM nutzen'
            ],
        ];
    }

    public function registerFormWidgets() {
        return [
            Location::class => 'zoomyboy_osm_location'
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'osm' => [
                'label'       => 'Karten',
                'url'         => Backend::url('zoomyboy/osm/index'),
                'icon'        => 'icon-map',
                'permissions' => ['zoomyboy.osm.*'],
                'order'       => 500,
                'sideMenu' => [
                    'point' => [
                        'label'       => 'Punkte',
                        'url'         => Backend::url('zoomyboy/osm/point'),
                        'icon'        => 'icon-map',
                        'permissions' => ['zoomyboy.osm.*'],
                        'order'       => 500,
                    ],
                    'point_category' => [
                        'label'       => 'Punkt-Kategorien',
                        'url'         => Backend::url('zoomyboy/osm/pointcategory'),
                        'icon'        => 'icon-map',
                        'permissions' => ['zoomyboy.osm.*'],
                        'order'       => 500,
                    ]
                ]
            ],
        ];
    }
}
