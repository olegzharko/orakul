import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { State } from '../../../../../../../../../../../../../../store/types';
import reqClientName from '../../../../../../../../../../../../../../services/generator/Client/reqClientName';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';

type InitialData = {
  surname_n: string;
  name_n: string;
  patronymic_n: string;
  surname_r: string;
  name_r: string;
  patronymic_r: string;
  surname_o: string;
  name_o: string;
  patronymic_o: string;
  surname_d: string;
  name_d: string;
  patronymic_d: string;
}

export type Props = {
  id: string;
  initialData?: InitialData;
}

export const useFio = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialData>({
    surname_n: '',
    name_n: '',
    patronymic_n: '',
    surname_r: '',
    name_r: '',
    patronymic_r: '',
    surname_o: '',
    name_o: '',
    patronymic_o: '',
    surname_d: '',
    name_d: '',
    patronymic_d: '',
  });

  useEffect(() => {
    setData({
      surname_n: initialData?.surname_n || '',
      name_n: initialData?.name_n || '',
      patronymic_n: initialData?.patronymic_n || '',
      surname_r: initialData?.surname_r || '',
      name_r: initialData?.name_r || '',
      patronymic_r: initialData?.patronymic_r || '',
      surname_o: initialData?.surname_o || '',
      name_o: initialData?.name_o || '',
      patronymic_o: initialData?.patronymic_o || '',
      surname_d: initialData?.surname_d || '',
      name_d: initialData?.name_d || '',
      patronymic_d: initialData?.patronymic_d || '',
    });
  }, [initialData]);

  const onClear = useCallback(() => {
    setData({
      surname_n: '',
      name_n: '',
      patronymic_n: '',
      surname_r: '',
      name_r: '',
      patronymic_r: '',
      surname_o: '',
      name_o: '',
      patronymic_o: '',
      surname_d: '',
      name_d: '',
      patronymic_d: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqClientName(token, '', id, 'PUT', data);
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
