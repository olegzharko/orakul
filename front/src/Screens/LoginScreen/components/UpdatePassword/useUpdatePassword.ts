/* eslint-disable implicit-arrow-linebreak */
import { useDispatch } from 'react-redux';
import { useState, useCallback, useMemo } from 'react';
import { useParams } from 'react-router-dom';
import resetPassword, {
  ResetPasswordType,
} from '../../../../services/login/resetPassword';

export const useUpdatePassword = () => {
  const { token } = useParams<{ token: string }>();
  const dispatch = useDispatch();

  const [email, setEmail] = useState<string>('');
  const [password, setPassword] = useState<string>('');
  const [repeatPassword, setRepeatPassword] = useState<string>('');

  const handleUpdate = useCallback(
    (e: any) => {
      e.preventDefault();
      const data: ResetPasswordType = {
        email,
        password,
        token,
        c_password: repeatPassword,
      };

      dispatch(resetPassword(data));
    },
    [email, password, token, repeatPassword, dispatch]
  );

  const disabledButton = useMemo(
    () => !password || !repeatPassword || password !== repeatPassword || !email,
    [password, repeatPassword, email]
  );

  return {
    email,
    password,
    repeatPassword,
    disabledButton,
    setEmail,
    setPassword,
    setRepeatPassword,
    handleUpdate,
  };
};
