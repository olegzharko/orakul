import { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import getLoginCarouselImages from '../../../../services/getLoginCarouselImages';
import { State } from '../../../../store/types';

export const useAuthorization = () => {
  const { token } = useSelector((state: State) => state.token);
  const [images, setImages] = useState<string[] | null>(null);

  useEffect(() => {
    if (token) {
      const fetchImages = async () => {
        const res = await getLoginCarouselImages(token);
        setImages(res.map((item: any) => item.image));
      };

      fetchImages();
    }
  }, [token]);

  return { images };
};
