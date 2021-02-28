/* eslint-disable import/prefer-default-export */
import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import fetchTag from '../actions/fetchTag';

export const useApp = () => {
  const dispatch = useDispatch();

  useEffect(() => {
    fetchTag(dispatch);
  }, []);
};
