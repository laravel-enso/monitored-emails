const MonitoredEmailIndex = () => import('../../pages/administration/Index.vue');

export default {
    name: 'administration.monitoredEmails.index',
    path: '',
    component: MonitoredEmailIndex,
    meta: {
        breadcrumb: 'index',
        title: 'Monitored Emails',
    },
};
