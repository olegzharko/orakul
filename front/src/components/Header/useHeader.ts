/* eslint-disable prettier/prettier */
import { useDispatch } from 'react-redux';
import { ChangeEvent, useState, useEffect } from 'react';
import { searchAppointments } from '../../store/scheduler/actions';
import useDebounce from './utils/useDebounce';

export const useHeader = () => {
  const dispatch = useDispatch();
  const [searchText, setSearchText] = useState<string>('');

  const debouncedValue = useDebounce(searchText, 1000);

  useEffect(() => {
    dispatch(searchAppointments(debouncedValue, 'calendar'));
  }, [debouncedValue]);

  const onSearch = (e: ChangeEvent<HTMLInputElement>) => {
    setSearchText(e.target.value);
  };

  return { onSearch, searchText };
};
