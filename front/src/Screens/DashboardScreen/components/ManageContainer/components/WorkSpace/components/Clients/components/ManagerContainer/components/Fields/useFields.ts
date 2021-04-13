import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { useEffect, useMemo, useCallback, useState } from 'react';
import { SelectItem } from '../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../store/types';
import reqManagerClient from '../../../../../../../../../../../../services/manager/Clients/reqManagerClient';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';

type Client = {
  surname: string | null,
  name: string | null,
  patronymic: string | null,
  phone: string | null,
  email: string | null,
  id?: string,
}

type SellerCheck = {
  passport: boolean,
  tax_code: boolean,
  evaluation_in_the_fund: boolean,
  check_fop: boolean,
  document_scans: boolean,
  unified_register_of_court_decisions: boolean,
  sanctions: boolean,
  financial_monitoring: boolean,
  unified_register_of_debtors: boolean,
}

type General = {
  spouse_consent: boolean,
  current_place_of_residence: boolean
  photo_in_the_passport: boolean,
  immigrant_help: boolean,
  married_type: string | null,
  document_type: string | null,
}

type Spouse = {
  surname: string | null;
  name: string | null;
  patronymic: string | null;
  id?: string;
}

export const useFields = () => {
  const dispatch = useDispatch();

  const { token } = useSelector((state: State) => state.main.user);
  const { clientId, personId } = useParams<{clientId: string, personId: string}>();

  // Selects
  const [marriedTypes, setMarriedTypes] = useState<SelectItem[]>([]);

  // Fields Data
  const [client, setClient] = useState<Client>({
    surname: null,
    name: null,
    patronymic: null,
    phone: null,
    email: null,
  });

  const [sellerCheck, setSellerCheck] = useState<SellerCheck>({
    passport: false,
    tax_code: false,
    evaluation_in_the_fund: false,
    check_fop: false,
    document_scans: false,
    unified_register_of_court_decisions: false,
    sanctions: false,
    financial_monitoring: false,
    unified_register_of_debtors: false,
  });

  const [general, setGeneral] = useState<General>({
    spouse_consent: false,
    current_place_of_residence: false,
    photo_in_the_passport: false,
    immigrant_help: false,
    married_type: null,
    document_type: null,
  });

  const [spouse, setSpouse] = useState<Spouse>({
    surname: null,
    name: null,
    patronymic: null,
  });

  const isCorrectId = useMemo(() => !Number.isNaN(parseFloat(personId)), [personId]);

  const onSave = useCallback(async () => {
    if (token) {
      const data = {
        ...client,
        ...sellerCheck,
        ...general,
        ...spouse,
      };

      const res = await reqManagerClient(token, personId, 'PUT', data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [token, client, sellerCheck, general, spouse]);

  useEffect(() => {
    if (token && isCorrectId) {
      // get CLIENT_DATA
      (async () => {
        const res = await reqManagerClient(token, personId);

        if (res?.success) {
          setClient(res?.data.client);
          setSellerCheck({
            passport: res?.data.passport || false,
            tax_code: res?.data.tax_code || false,
            evaluation_in_the_fund: res?.data.evaluation_in_the_fund || false,
            check_fop: res?.data.check_fop || false,
            document_scans: res?.data.document_scans || false,
            unified_register_of_court_decisions:
              res?.data.unified_register_of_court_decisions || false,
            sanctions: res?.data.sanctions || false,
            financial_monitoring: res?.data.financial_monitoring || false,
            unified_register_of_debtors: res?.data.unified_register_of_debtors || false,
          });
          setSpouse(res?.data.spouse);
          setMarriedTypes(res?.data.married_types || []);
          setGeneral({
            spouse_consent: res?.data.spouse_consent || false,
            current_place_of_residence: res?.data.current_place_of_residence || false,
            photo_in_the_passport: res?.data.photo_in_the_passport || false,
            immigrant_help: res?.data.immigrant_help || false,
            married_type: res?.data.married_type || null,
            document_type: res?.data.document_type || null,
          });
        }
      })();
    }
  }, [token, personId]);

  return {
    clientId,
    personId,
    client,
    sellerCheck,
    spouse,
    marriedTypes,
    general,
    setGeneral,
    setSpouse,
    setSellerCheck,
    setClient,
    onSave,
  };
};
