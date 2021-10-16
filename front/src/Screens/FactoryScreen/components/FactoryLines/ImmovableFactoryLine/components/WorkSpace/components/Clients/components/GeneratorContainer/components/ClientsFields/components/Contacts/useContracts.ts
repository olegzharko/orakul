import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';

import { State } from '../../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../../store/main/actions';
import reqClientContacts from '../../../../../../../../../../../../../../../services/generator/Client/reqClientContacts';

type InitialData = {
  email: string | null,
  phone: string | null,
}

export type Props = {
  id: string;
  initialData?: InitialData,
}

export const useContracts = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialData>({
    email: '',
    phone: '',
  });

  useEffect(() => {
    setData({
      email: initialData?.email || '',
      phone: initialData?.phone || '',
    });
  }, [initialData]);

  const onClear = useCallback(() => {
    setData({
      email: '',
      phone: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqClientContacts(token, id, 'PUT', data);
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
