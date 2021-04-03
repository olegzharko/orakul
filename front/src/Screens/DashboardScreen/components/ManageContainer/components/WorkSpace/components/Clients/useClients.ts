import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';

export const useClients = () => {
  const { user } = useSelector((state: State) => state.main);

  return {
    type: user.type,
  };
};
