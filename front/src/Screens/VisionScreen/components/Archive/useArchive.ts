import { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import { State } from '../../../../store/types';

export const useArchive = () => {
  const { token } = useSelector((state: State) => state.main.user);

  // State
  const [isLoading, setIsLoading] = useState<boolean>(true);

  // Effects
  // useEffect(() => {

  // }, []);

  return {
    isLoading,
  };
};
