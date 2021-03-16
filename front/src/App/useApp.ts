/* eslint-disable import/prefer-default-export */
import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import { fetchToken } from '../store/token/actions';

export const useApp = () => {
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(fetchToken());
  }, []);
};
