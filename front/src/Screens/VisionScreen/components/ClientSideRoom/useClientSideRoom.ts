import { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import { useParams } from 'react-router-dom';

import getDealDetail from '../../../../services/vision/space/getDealDetail';

import { State } from '../../../../store/types';

export const useClientSideRoom = () => {
  const { token } = useSelector((state: State) => state.main.user);
  const { dealId } = useParams<{dealId: string}>();

  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    (async () => {
      if (token) {
        const res = await getDealDetail(token, dealId);
        setIsLoading(false);
        console.log(res);
      }
    })();
  }, [dealId, token]);

  return {
    isLoading,
  };
};
