// eslint-disable-next-line object-curly-newline
import { useCallback, useEffect, useMemo, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import getLoginCarouselImages from '../../../../services/getLoginCarouselImages';
import { sendLogin } from '../../../../store/main/actions';
import { State } from '../../../../store/types';

export const useAuthorization = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main);
  const [images, setImages] = useState<string[] | null>(null);
  const [email, setEmail] = useState<string>('');
  const [password, setPassword] = useState<string>('');

  const handleLogin = useCallback(() => {
    dispatch(sendLogin({ email, password }));
  }, [password, email]);

  const disabledButton = useMemo(() => !email || !password, [email, password]);

  useEffect(() => {
    if (token) {
      const fetchImages = async () => {
        const res = await getLoginCarouselImages(token);
        setImages(res.map((item: any) => item.image));
      };

      fetchImages();
    }
  }, [token]);

  return {
    email,
    setEmail,
    password,
    setPassword,
    images,
    handleLogin,
    disabledButton,
  };
};
