import { useMemo } from 'react';
import { useHistory, useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';

import { UserTypes } from '../../../../../../../types';
import { State } from '../../../../../../../store/types';

export const useNavigation = () => {
  const history = useHistory();
  const { lineItemId } = useParams<{ lineItemId: string }>();
  const { user } = useSelector((state: State) => state.main);

  const handleClick = (baseLink: string) => {
    history.push(`${baseLink}/${lineItemId}`);
  };

  const shouldShowSeller = useMemo(() => user.type === UserTypes.GENERATOR, [user.type]);
  const shouldShowImmovable = useMemo(() => user.type !== UserTypes.ASSISTANT, [user.type]);
  const shouldShowClient = useMemo(() => user.type !== UserTypes.ASSISTANT, [user.type]);
  const shouldShowSideNotaries = useMemo(() => user.type === UserTypes.GENERATOR, [user.type]);

  return {
    shouldShowSeller,
    shouldShowImmovable,
    shouldShowClient,
    shouldShowSideNotaries,
    handleClick,
  };
};
