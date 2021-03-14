/* eslint-disable import/prefer-default-export */
import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import fetchToken from '../actions/fetchTocken';

export const useApp = () => {
  const dispatch = useDispatch();

  useEffect(() => {
    fetchToken(dispatch);
  }, []);
};
