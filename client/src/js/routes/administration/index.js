const MonitoredEmailIndex = () => import('../../pages/administration/Index.vue');

export default {
    name: 'administration.index',
    path: '',
    component: MonitoredEmailIndex,
    meta: {
        breadcrumb: 'index',
        title: 'Monitored Emails',
    },
};
