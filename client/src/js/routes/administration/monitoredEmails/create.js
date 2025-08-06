const MonitoredEmailCreate = () => import('../../../pages/administration/monitoredEmails/Create.vue');

export default {
    name: 'administration.monitoredEmails.create',
    path: 'create',
    component: MonitoredEmailCreate,
    meta: {
        breadcrumb: 'create',
        title: 'Create Monitored Email',
    },
};
