import { useSelector, useDispatch } from 'react-redux';
/* eslint-disable import/prefer-default-export */
import { useEffect } from 'react';
import { setUser } from '../store/main/actions';
import { State } from '../store/types';

export const useApp = () => {
  const dispatch = useDispatch();
  const { user } = useSelector((state: State) => state.main);

  useEffect(() => {
    const localUser = localStorage.getItem('user');

    if (localUser) {
      dispatch(setUser(JSON.parse(localUser)));
    }
  }, []);

  return { type: user.type };
};
