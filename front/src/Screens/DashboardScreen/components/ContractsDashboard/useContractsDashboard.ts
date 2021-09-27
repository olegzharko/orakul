import { useCallback, useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';
import { useParams } from 'react-router';
import { useHistory } from 'react-router-dom';

import getContractsDashboardByProcess from '../../../../services/getContractsDashboardByProcess';
import { State } from '../../../../store/types';

export type ContractCard = {
  id: number;
  list: string[];
  title: string;
}

export const useContractsDashboard = () => {
  const history = useHistory();

  const { token } = useSelector((state: State) => state.main.user);
  const { process, cardId } = useParams<{process: string, cardId: string}>();

  // Store
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [cards, setCards] = useState<ContractCard[]>([]);

  // Memo
  const formattedCards = useMemo(() => cards.map((card) => ({
    ...card,
    onClick: () => history.push(`/${process}/${cardId}/checklist/${card.id}`),
  })), [cardId, cards, history, process]);

  // Effects
  useEffect(() => {
    (async () => {
      if (!token) return;

      try {
        const res = await getContractsDashboardByProcess(token, process, cardId);
        setCards(res);
      } catch (e: any) {
        alert(e.message);
        console.error(e);
      } finally {
        setIsLoading(false);
      }
    })();
  }, [cardId, process, token]);

  return {
    isLoading,
    formattedCards,
  };
};
