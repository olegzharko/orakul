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

export const formatClientsCards = (
  clients: any,
  history: any,
  baseLink: string,
): AssistantSection[] => Object.values(clients).map((client: any) => ({
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
