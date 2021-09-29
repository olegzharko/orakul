// eslint-disable-next-line object-curly-newline
import { useCallback, useEffect, useMemo, useState } from 'react';
import { useDispatch } from 'react-redux';
import getLoginCarouselImages from '../../../../services/getLoginCarouselImages';
import { sendLogin } from '../../../../store/main/actions';

export const useAuthorization = () => {
  const dispatch = useDispatch();
  const [images, setImages] = useState<string[]>([]);
  const [email, setEmail] = useState<string>('');
  const [password, setPassword] = useState<string>('');
  const [remember, setRemember] = useState<boolean>(false);

  const handleLogin = useCallback(
    (e: any) => {
      e.preventDefault();
      dispatch(sendLogin({ email, password }, remember));
    },
    [dispatch, email, password, remember]
  );

  const disabledButton = useMemo(() => !email || !password, [email, password]);

  useEffect(() => {
    const fetchImages = async () => {
      const res = await getLoginCarouselImages();
      if (!res) return;
      setImages(res.map((item: any) => item.image));
    };
    fetchImages();
  }, []);

  return {
    email,
    password,
    images,
    disabledButton,
    handleLogin,
    setRemember,
    setPassword,
    setEmail,
  };
};
