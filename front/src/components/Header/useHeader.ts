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
  const [count, setCount] = useState<number>(0);

  const debouncedValue = useDebounce(searchText, 1000);

  useEffect(() => {
    if (!count) {
      setCount((prev: number) => prev + 1);
      return;
    }

    dispatch(searchAppointments(debouncedValue, 'calendar'));
  }, [debouncedValue]);

  const onSearch = useCallback((e: ChangeEvent<HTMLInputElement>) => {
    setSearchText(e.target.value);
  }, [searchText]);

  const onLogout = useCallback(() => {
    localStorage.clear();
    dispatch(setUser({ type: null, token: null }));
  }, []);

  return { onSearch, onLogout, searchText };
};
