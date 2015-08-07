<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;

/**
 * This is the dashboard routes class.
 *
 * @author James Brooks <james@alt-three.com>
 */
class DashboardRoutes
{
    /**
     * Define the dashboard routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     */
    public function map(Registrar $router)
    {
        $router->group([
            'middleware' => 'auth',
            'prefix'     => 'dashboard',
            'namespace'  => 'Admin',
            'as'         => 'dashboard.',
        ], function ($router) {
            // Dashboard
            $router->get('/', [
                'as'   => 'index',
                'uses' => 'DashboardController@showDashboard',
            ]);

            // Components
            $router->group(['prefix' => 'components'], function ($router) {
                $router->get('/', [
                    'as'   => 'components',
                    'uses' => 'ComponentController@showComponents',
                ]);
                $router->get('add', [
                    'as'   => 'components.add',
                    'uses' => 'ComponentController@showAddComponent',
                ]);
                $router->post('add', 'ComponentController@createComponentAction');
                $router->get('groups', [
                    'as'   => 'components.groups',
                    'uses' => 'ComponentController@showComponentGroups',
                ]);
                $router->get('groups/add', [
                    'as'   => 'components.groups.add',
                    'uses' => 'ComponentController@showAddComponentGroup',
                ]);
                $router->get('groups/edit/{component_group}', [
                    'as'   => 'components.groups.edit',
                    'uses' => 'ComponentController@showEditComponentGroup',
                ]);
                $router->post('groups/edit/{component_group}', 'ComponentController@updateComponentGroupAction');

                $router->delete('groups/{component_group}/delete', 'ComponentController@deleteComponentGroupAction');
                $router->post('groups/add', 'ComponentController@postAddComponentGroup');

                $router->get('{component}/edit', [
                    'as'   => 'component.edit',
                    'uses' => 'ComponentController@showEditComponent',
                ]);
                $router->delete('{component}/delete', 'ComponentController@deleteComponentAction');
                $router->post('{component}/edit', 'ComponentController@updateComponentAction');
            });

            // Incidents
            $router->group(['prefix' => 'incidents'], function ($router) {
                $router->get('/', [
                    'as'   => 'incidents',
                    'uses' => 'IncidentController@showIncidents',
                ]);
                $router->get('add', [
                    'as'   => 'incidents.add',
                    'uses' => 'IncidentController@showAddIncident',
                ]);
                $router->post('add', 'IncidentController@createIncidentAction');
                $router->delete('{incident}/delete', 'IncidentController@deleteIncidentAction');
                $router->get('{incident}/edit', 'IncidentController@showEditIncidentAction');
                $router->post('{incident}/edit', 'IncidentController@editIncidentAction');
            });

            // Scheduled Maintenance
            $router->group(['prefix' => 'schedule'], function ($router) {
                $router->get('/', [
                    'as'   => 'schedule',
                    'uses' => 'ScheduleController@showIndex',
                ]);

                $router->get('add', [
                    'as'   => 'schedule.add',
                    'uses' => 'ScheduleController@showAddSchedule',
                ]);

                $router->post('add', 'ScheduleController@addScheduleAction');

                $router->get('{incident}/edit', [
                    'as'   => 'schedule.edit',
                    'uses' => 'ScheduleController@showEditSchedule',
                ]);

                $router->post('{incident}/edit', 'ScheduleController@editScheduleAction');

                $router->delete('{incident}/delete', [
                    'as'   => 'schedule.delete',
                    'uses' => 'ScheduleController@deleteScheduleAction',
                ]);
            });

            // Incident Templates
            $router->group(['prefix' => 'templates'], function ($router) {
                $router->get('/', [
                    'as'   => 'templates',
                    'uses' => 'IncidentController@showTemplates',
                ]);

                $router->get('add', [
                    'as'   => 'templates.add',
                    'uses' => 'IncidentController@showAddIncidentTemplate',
                ]);
                $router->post('add', 'IncidentController@createIncidentTemplateAction');

                $router->get('{incident_template}/edit', 'IncidentController@showEditTemplateAction');
                $router->post('{incident_template}/edit', 'IncidentController@editTemplateAction');
                $router->delete('{incident_template}/delete', 'IncidentController@deleteTemplateAction');
            });

            // Subscribers
            $router->group(['prefix' => 'subscribers'], function ($router) {
                $router->get('/', [
                    'as'   => 'subscribers',
                    'uses' => 'SubscriberController@showSubscribers',
                ]);

                $router->get('add', [
                    'as'   => 'subscribers.add',
                    'uses' => 'SubscriberController@showAddSubscriber',
                ]);
                $router->post('add', 'SubscriberController@createSubscriberAction');

                $router->delete('{subscriber}/delete', 'SubscriberController@deleteSubscriberAction');
            });

            // Metrics
            $router->group(['prefix' => 'metrics'], function ($router) {
                $router->get('/', [
                    'as'   => 'metrics',
                    'uses' => 'MetricController@showMetrics',
                ]);

                $router->get('add', [
                    'as'   => 'metrics.add',
                    'uses' => 'MetricController@showAddMetric',
                ]);
                $router->post('add', 'MetricController@createMetricAction');
                $router->delete('{metric}/delete', 'MetricController@deleteMetricAction');
                $router->get('{metric}/edit', 'MetricController@showEditMetricAction');
                $router->post('{metric}/edit', 'MetricController@editMetricAction');
            });

            // Notifications
            $router->group(['prefix' => 'notifications'], function ($router) {
                $router->get('/', [
                    'as'   => 'notifications',
                    'uses' => 'DashboardController@showNotifications',
                ]);
            });

            // Team Members
            $router->group(['prefix' => 'team'], function ($router) {
                $router->get('/', [
                    'as'   => 'team',
                    'uses' => 'TeamController@showTeamView',
                ]);

                $router->group(['middleware' => 'admin'], function ($router) {
                    $router->get('add', [
                        'as'   => 'team.add',
                        'uses' => 'TeamController@showAddTeamMemberView',
                    ]);
                    $router->get('{user}', 'TeamController@showTeamMemberView');
                    $router->post('add', 'TeamController@postAddUser');
                    $router->post('{user}', 'TeamController@postUpdateUser');
                    $router->delete('{user}/delete', 'TeamController@deleteUser');
                });
            });

            // Settings
            $router->group(['prefix' => 'settings'], function ($router) {
                $router->get('setup', [
                    'as'   => 'settings.setup',
                    'uses' => 'SettingsController@showSetupView',
                ]);
                $router->get('security', [
                    'as'   => 'settings.security',
                    'uses' => 'SettingsController@showSecurityView',
                ]);
                $router->get('theme', [
                    'as'   => 'settings.theme',
                    'uses' => 'SettingsController@showThemeView',
                ]);
                $router->get('stylesheet', [
                    'as'   => 'settings.stylesheet',
                    'uses' => 'SettingsController@showStylesheetView',
                ]);
                $router->post('/', 'SettingsController@postSettings');
            });

            // User Settings
            $router->group(['prefix' => 'user'], function ($router) {
                $router->get('/', [
                    'as'   => 'user',
                    'uses' => 'UserController@showUser',
                ]);
                $router->post('/', 'UserController@postUser');
                $router->get('{user}/api/regen', 'UserController@regenerateApiKey');
            });

            // Internal API.
            // This should only be used for making requests within the dashboard.
            $router->group(['prefix' => 'api'], function ($router) {
                $router->get('incidents/templates', 'ApiController@getIncidentTemplate');
                $router->post('components/groups/order', 'ApiController@postUpdateComponentGroupOrder');
                $router->post('components/order', 'ApiController@postUpdateComponentOrder');
                $router->post('components/{component}', 'ApiController@postUpdateComponent');
            });
        });
    }
}
