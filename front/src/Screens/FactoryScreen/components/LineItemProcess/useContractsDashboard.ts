import { useCallback, useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';
import { useParams } from 'react-router';
import { useHistory } from 'react-router-dom';
import routes from '../../../../routes';

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
  const { processType, lineItemId } = useParams<{processType: string, lineItemId: string}>();

  // Store
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [cards, setCards] = useState<ContractCard[]>([]);

  // Memo
  const formattedCards = useMemo(() => cards.map((card) => ({
    ...card,
    onClick: () => history.push(
      routes.factory.processLineItem.checkList.linkTo(processType, lineItemId, card.id)
    ),
  })), [lineItemId, cards, history, processType]);

  // Effects
  useEffect(() => {
    (async () => {
      if (!token) return;

      try {
        const res = await getContractsDashboardByProcess(token, processType, lineItemId);
        setCards(res);
      } catch (e: any) {
        console.error(e);
      } finally {
        setIsLoading(false);
      }
    })();
  }, [lineItemId, processType, token]);

  return {
    isLoading,
    formattedCards,
    processType,
    lineItemId,
  };
};
