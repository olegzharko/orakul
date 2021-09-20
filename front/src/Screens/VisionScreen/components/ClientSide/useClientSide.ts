import { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';

import { State } from '../../../../store/types';

import { loadSpaceInfo } from './actions';

export const useClientSide = () => {
  const { token } = useSelector((state: State) => state.main.user);

  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [reception, setReception] = useState<any>([]);

  useEffect(() => {
    (async () => {
      if (token) {
        const [reception] = await loadSpaceInfo(token);
        setReception(reception || []);
        setIsLoading(false);
      }
    })();
  }, [token]);

  return {
    isLoading,
    reception,
  };
};
