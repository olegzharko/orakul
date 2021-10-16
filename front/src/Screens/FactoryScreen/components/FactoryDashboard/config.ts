import routes from '../../../../routes';

export const assistant_info_navigation = [
  {
    title: 'Набір: ',
    link: routes.factory.dashboard.set.path,
  },
  {
    title: 'Читка: ',
    link: routes.factory.dashboard.reading.path,
  },
  {
    title: 'Видача: ',
    link: routes.factory.dashboard.accompanying.path,
  },
];
