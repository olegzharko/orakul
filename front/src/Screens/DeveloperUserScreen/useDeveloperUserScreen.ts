import { useState, useEffect } from 'react';
import { useSelector } from 'react-redux';

import getDeveloperCards, { DeveloperSectionsCards } from '../../services/developerScreen/getDeveloperCards';
import { State } from '../../store/types';

export const useDeveloperUserScreen = () => {
  const { token } = useSelector((state: State) => state.main.user);

  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [sectionsCards, setSectionsCards] = useState<DeveloperSectionsCards[]>([]);

  // Effects
  useEffect(() => {
    (async () => {
      if (!token) return;

      const res = await getDeveloperCards(token);

      if (res.success) {
        setSectionsCards(Object.values(res.data));
      }

      setIsLoading(false);
    })();
  }, [token]);

  return {
    isLoading,
    sectionsCards,
  };
};
