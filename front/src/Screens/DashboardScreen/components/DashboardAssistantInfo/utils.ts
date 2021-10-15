import { UserTypes } from '../../../../types';
import { MANAGE_CONTAINER_LINK_PREFIX, MANAGE_PROCESS_LINK_PREFIX } from '../../constants';
import { DashboardAssistantInfoNavigationLinks } from '../../enums';

export type AssistantSection = {
  title: string;
  cards: {
    id: number,
    title: string,
    content: string[],
    color: string,
    onClick: () => void,
  }[];
}

const formatClientsCards = (
  clients: any,
  history: any,
  baseLink: string,
): AssistantSection[] => Object.values(clients || {}).map((client: any) => ({
  title: `${client.day || ''} ${client.date || ''}`,
  cards: client.cards?.map((card: any) => ({
    id: card.id,
    title: card.title,
    content: card.instructions,
    color: card.color,
    onClick: () => {
      history.push(`${baseLink}/${card.id}`);
    }
  }))
}));

export const formatAssistantData = (data: any, history: any, userType: UserTypes) => {
  if (userType === UserTypes.GENERATOR) {
    return [
      formatClientsCards(data.generator, history, `${MANAGE_CONTAINER_LINK_PREFIX}/main`),
      formatClientsCards(
        data.reader,
        history,
        `${MANAGE_PROCESS_LINK_PREFIX}${DashboardAssistantInfoNavigationLinks.reading}`
      ),
      formatClientsCards(
        data.accompanying,
        history,
        `${MANAGE_PROCESS_LINK_PREFIX}${DashboardAssistantInfoNavigationLinks.accompanying}`
      ),
    ];
  }

  return [formatClientsCards(data, history, `${MANAGE_CONTAINER_LINK_PREFIX}/main`)];
};

type AssistantInfoNavigationValuesRequest = {
  generate: {ready: number, total: number},
  read: {ready: number, total: number},
  accompanying: {ready: number, total: number},
}

export const formatNavigationValues = (data: AssistantInfoNavigationValuesRequest): string[] => {
  const generateStr = data?.generate ? `${data?.generate.ready}/${data?.generate.total}` : '';
  const readStr = data?.read ? `${data?.read.ready}/${data?.read.total}` : '';
  const accompanyingStr = data?.accompanying ? `${data?.accompanying.ready}/${data?.accompanying.total}` : '';

  return [
    generateStr,
    readStr,
    accompanyingStr,
  ];
};
