import { MANAGE_CONTAINER_LINK_PREFIX } from '../../constants';

export const formatClientsCards = (
  clients: any,
  history: any,
) => Object.values(clients).map((client: any) => ({
  title: `${client.day || ''} ${client.date || ''}`,
  cards: client.cards?.map((card: any) => ({
    id: card.id,
    title: card.title,
    content: card.instructions,
    color: card.color,
    onClick: () => {
      history.push(`${MANAGE_CONTAINER_LINK_PREFIX}/main/${card.id}`);
    }
  }))
}));
