import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useEffect, useCallback, useState } from 'react';

import { State } from '../../../../../../../../../../../store/types';
import getSideNotaries from '../../../../../../../../../../../services/generator/SideNotary/getSideNotaries';

type SideNotary = {
  id: number,
  title: string,
  list: string[]
}

export const useDashboard = () => {
  const history = useHistory();

  const { lineItemId } = useParams<{ lineItemId: string }>();
  const { token } = useSelector((state: State) => state.main.user);

  const [notaries, setNotaries] = useState<SideNotary[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>();

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  useEffect(() => {
    if (token) {
      // get SIDE_NOTARIES
      (async () => {
        setIsLoading(true);
        const res = await getSideNotaries(token, lineItemId);

        if (res.success) {
          setNotaries(res.data.notary);
        }
        setIsLoading(false);
      })();
    }
  }, [token, lineItemId]);

  return {
    lineItemId,
    isLoading,
    notaries,
    onCardClick,
  };
};
