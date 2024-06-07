import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';

import { State } from '../../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../../store/main/actions';
import reqClientWork from '../../../../../../../../../../../../../../../services/generator/Client/reqClientWork';

type InitialData = {
  company: string | null,
  position: string | null,
}

export type Props = {
  id: string;
  initialData?: InitialData,
}

export const useWork = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialData>({
    company: '',
    position: '',
  });

  useEffect(() => {
    setData({
      company: initialData?.company || '',
      position: initialData?.position || '',
    });
  }, [initialData]);

  const onClear = useCallback(() => {
    setData({
      company: '',
      position: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqClientWork(token, id, 'PUT', data);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, dispatch, id, token]);

  return {
    data,
    setData,
    onClear,
    onSave,
  };
};
