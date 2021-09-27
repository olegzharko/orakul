import { useHistory } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import {
  ChangeEvent, useState, useEffect, useCallback
} from 'react';
import { setUser } from '../../store/main/actions';
import { searchAppointments } from '../../store/appointments/actions';
import useDebounce from './utils/useDebounce';

export const useHeader = () => {
  const dispatch = useDispatch();
  const history = useHistory();
  const [searchText, setSearchText] = useState<string>('');
  const [count, setCount] = useState<number>(0);

  const debouncedValue = useDebounce(searchText, 1000);

  useEffect(() => {
    if (!count) {
      setCount(count + 1);
      return;
    }

    dispatch(searchAppointments(debouncedValue));
  }, [count, debouncedValue, dispatch]);

  const onSearch = useCallback((e: ChangeEvent<HTMLInputElement>) => {
    setSearchText(e.target.value);
  }, []);

  const onLogout = useCallback(() => {
    localStorage.clear();
    dispatch(setUser({ type: null, token: null }));
    history.push('/');
  }, [dispatch, history]);

  return {
    onSearch,
    onLogout,
    searchText,
  };
};
