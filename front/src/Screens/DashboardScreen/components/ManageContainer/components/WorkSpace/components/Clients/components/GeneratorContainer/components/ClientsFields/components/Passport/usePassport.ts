import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect, useMemo } from 'react';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientPassport from '../../../../../../../../../../../../../../services/generator/Client/reqClientPassport';
import { formatDate, changeMonthWitDate } from '../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
  gender: string,
  date_of_birth: any,
  tax_code: string,
  passport_type_id: string,
  passport_code: string,
  passport_date: any
  passport_department: string,
  passport_demographic_code: string,
  passport_finale_date: any,
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
    tax_code: '',
    passport_type_id: '',
    passport_code: '',
    passport_department: '',
    passport_demographic_code: '',
    passport_date: null,
    passport_finale_date: null,
    date_of_birth: null,
  });

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
      tax_code: '',
      passport_type_id: '',
      passport_code: '',
      passport_department: '',
      passport_demographic_code: '',
      passport_date: null,
      passport_finale_date: null,
      date_of_birth: null,

    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        date_of_birth: formatDate(data.date_of_birth),
        passport_date: formatDate(data.passport_date),
        passport_finale_date: formatDate(data.passport_finale_date),
      };

      const { success, message } = await reqClientPassport(token, id, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, dispatch, id, token]);

  useEffect(() => {
    setPassportTypes(initialData?.passport_types || []);
    setData({
      gender: initialData?.gender || 'female',
      tax_code: initialData?.tax_code || '',
      passport_type_id: initialData?.passport_type_id || '',
      passport_code: initialData?.passport_code || '',
      passport_department: initialData?.passport_department || '',
      passport_demographic_code: initialData?.passport_demographic_code || '',
      passport_finale_date: initialData?.passport_finale_date
        ? changeMonthWitDate(initialData?.passport_finale_date) : null,
      date_of_birth: initialData?.date_of_birth
        ? changeMonthWitDate(initialData?.date_of_birth) : null,
      passport_date: initialData?.passport_date
        ? changeMonthWitDate(initialData?.passport_date) : null,
    });
  }, [initialData]);

  return {
    sexButtons,
    passportTypes,
    data,
    setData,
    onClear,
    onSave,
  };
};
