/* eslint-disable prettier/prettier */
import { useDispatch } from 'react-redux';
import {
  ChangeEvent, useState, useEffect, useCallback
} from 'react';
import { setUser } from '../../store/main/actions';
import { searchAppointments } from '../../store/scheduler/actions';
import useDebounce from './utils/useDebounce';

export const useHeader = () => {
  const dispatch = useDispatch();
  const [searchText, setSearchText] = useState<string>('');

  const debouncedValue = useDebounce(searchText, 1000);

  useEffect(() => {
    dispatch(searchAppointments(debouncedValue, 'calendar'));
  }, [debouncedValue]);

  const onSearch = useCallback(() => (e: ChangeEvent<HTMLInputElement>) => {
    setSearchText(e.target.value);
  }, []);

  const onLogout = useCallback(() => {
    localStorage.clear();
    dispatch(setUser({ type: null, token: null }));
  }, []);

  return { onSearch, onLogout, searchText };
};
