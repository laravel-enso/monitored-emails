const MonitoredEmailCreate = () => import('../../pages/administration/Create.vue');

export default {
    name: 'administration.create',
    path: 'create',
    component: MonitoredEmailCreate,
    meta: {
        breadcrumb: 'create',
        title: 'Create Monitored Email',
    },
};
