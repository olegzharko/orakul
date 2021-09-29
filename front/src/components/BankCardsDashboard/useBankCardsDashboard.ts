import { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';

import getBank from '../../services/vision/bank/getBank';
import { State } from '../../store/types';
import { BankCard } from './types';

export const useBankCardsDashboard = () => {
  const { token } = useSelector((state: State) => state.main.user);

  // State
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [cards, setCards] = useState<BankCard[]>();

  // Effects
  useEffect(() => {
    (async () => {
      if (!token) return;

      try {
        const res = await getBank(token);
        setCards(res);
      } catch (e: any) {
        console.error(e);
      } finally {
        setIsLoading(false);
      }
    })();
  }, [token]);

  return {
    isLoading,
    cards,
  };
};
