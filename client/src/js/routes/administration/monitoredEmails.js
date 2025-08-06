import routeImporter from '@enso-ui/ui/src/modules/importers/routeImporter';

const routes = routeImporter(require.context('./monitoredEmails', false, /.*\.js$/));
const RouterView = () => import('@enso-ui/ui/src/bulma/pages/Router.vue');

export default {
    path: 'monitoredEmails',
    component: RouterView,
    meta: {
        breadcrumb: 'monitoredEmails',
        route: 'administration.monitoredEmails.index',
    },
    children: routes,
};
