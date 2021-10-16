import routes from '../../routes';

export const navigation = [
  {
    title: 'Клієнтський простір',
    link: routes.vision.clientSide.linkTo,
  },
  {
    title: 'Помічники',
    link: routes.vision.assistants.linkTo,
  },
  {
    title: 'Банк',
    link: routes.vision.bank.linkTo,
  },
  {
    title: 'Архів',
    link: routes.vision.archive.linkTo,
  },
];
