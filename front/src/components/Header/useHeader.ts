import { useHistory } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import {
  ChangeEvent, useState, useCallback
} from 'react';
import _ from 'lodash';

import { setUser } from '../../store/main/actions';
import { searchAppointments } from '../../store/appointments/actions';

export const useHeader = () => {
  const dispatch = useDispatch();
  const history = useHistory();

  const [searchText, setSearchText] = useState<string>('');

  const onDebouncedSearch = useCallback(
    _.debounce((e) => dispatch(searchAppointments(e)), 500), []
  );

  const onSearch = useCallback((e: ChangeEvent<HTMLInputElement>) => {
    onDebouncedSearch(e.target.value);
    setSearchText(e.target.value);
  }, [onDebouncedSearch]);

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
