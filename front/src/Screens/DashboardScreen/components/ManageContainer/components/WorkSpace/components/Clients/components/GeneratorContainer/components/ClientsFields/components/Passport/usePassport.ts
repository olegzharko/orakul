import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect, useMemo } from 'react';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientPassport from '../../../../../../../../../../../../../../services/generator/Client/reqClientPassport';

type InitialData = {
  gender: string,
  date_of_birth: string,
  tax_code: string,
  passport_type_id: string,
  passport_code: string,
  passport_date: string
  passport_department: string,
  passport_demographic_code: string,
  passport_finale_date: string,
  passport_types?: SelectItem[],
}

export type Props = {
  id: string;
  initialData?: InitialData;
}

export const usePassport = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [passportTypes, setPassportTypes] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    gender: 'female',
    date_of_birth: '',
    tax_code: '',
    passport_type_id: '',
    passport_code: '',
    passport_date: '',
    passport_department: '',
    passport_demographic_code: '',
    passport_finale_date: '',
  });

  useEffect(() => {
    setPassportTypes(initialData?.passport_types || []);
    setData({
      gender: initialData?.gender || 'female',
      date_of_birth: initialData?.date_of_birth || '',
      tax_code: initialData?.tax_code || '',
      passport_type_id: initialData?.passport_type_id || '',
      passport_code: initialData?.passport_code || '',
      passport_date: initialData?.passport_date || '',
      passport_department: initialData?.passport_department || '',
      passport_demographic_code: initialData?.passport_demographic_code || '',
      passport_finale_date: initialData?.passport_finale_date || '',
    });
  }, [initialData]);

  const sexButtons = useMemo(() => [
    {
      id: 'female',
      title: 'Жіноча',
    },
    {
      id: 'male',
      title: 'Чоловіча'
    }
  ], []);

  const onClear = useCallback(() => {
    setData({
      gender: 'female',
      date_of_birth: '',
      tax_code: '',
      passport_type_id: '',
      passport_code: '',
      passport_date: '',
      passport_department: '',
      passport_demographic_code: '',
      passport_finale_date: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqClientPassport(token, id, 'PUT', data);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  return {
    sexButtons,
    passportTypes,
    data,
    setData,
    onClear,
    onSave,
  };
};
