/* eslint-disable implicit-arrow-linebreak */
import { useDispatch, useSelector } from 'react-redux';
import { useState, useCallback, useMemo } from 'react';
import { State } from '../../../../store/types';
import { setModalInfo, forgotPassword } from '../../../../store/main/actions';

export const useForgotPassword = () => {
  const dispatch = useDispatch();
  const [email, setEmail] = useState<string>('');

  const handleReset = useCallback(
    (e: any) => {
      e.preventDefault();
      dispatch(forgotPassword({ email }));
    },
    [email]
  );

  const disabledButton = useMemo(() => !email, [email]);

  return {
    email,
    disabledButton,
    setEmail,
    handleReset,
  };
};
