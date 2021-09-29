import { useHistory } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import {
  ChangeEvent, useState, useCallback, useMemo
} from 'react';
import _ from 'lodash';

import { setUser } from '../../store/main/actions';
import { searchAppointments } from '../../store/appointments/actions';
import { State } from '../../store/types';
import { UserTypes } from '../../types';

export const useHeader = () => {
  const dispatch = useDispatch();
  const history = useHistory();

  const { type } = useSelector((state: State) => state.main.user);

  const [searchText, setSearchText] = useState<string>('');

  // Memo
  const isNotCompanyUser = useMemo(
    () => type === UserTypes.BANK || type === UserTypes.DEVELOPER, [type]
  );

  // eslint-disable-next-line react-hooks/exhaustive-deps
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
    searchText,
    isNotCompanyUser,
    onSearch,
    onLogout,
  };
};
