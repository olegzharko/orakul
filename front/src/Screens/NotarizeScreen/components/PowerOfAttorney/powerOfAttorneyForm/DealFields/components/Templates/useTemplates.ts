import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { changeMonthWitDate, formatDate } from '../../../../../../../../utils/formatDates';
import { SelectItem } from '../../../../../../../../types';
import { setModalInfo } from '../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../store/types';
import reqPowerOfAttorneyTemplate from '../../../../../../../../services/notarize/PowerOfAttorney/Template/reqPowerOfAttorneyTemplate';
import Contract from '../../../../../../../FactoryScreen/components/FactoryLines/ImmovableFactoryLine/components/WorkSpace/components/Immovable/components/ManagerContainer/components/Fields/components/Contract';

type InitialData = {
  contract_templates?: any,
  contract_template_id: number | null,
  issue_date: any,
  expiry_date: any,
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useTemplates = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [contractTemplates, setContractTemplates] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    contract_template_id: null,
    issue_date: null,
    expiry_date: null,
  });

  const onClear = useCallback(() => {
    setData({
      contract_template_id: null,
      issue_date: null,
      expiry_date: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        contract_template_id: data.contract_template_id,
        issue_date: formatDate(data.issue_date),
        expiry_date: formatDate(data.expiry_date)
      };

      const res = await reqPowerOfAttorneyTemplate(token, id, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );

      if (res?.success && res?.data?.link) {
        res.data.link.forEach((link: string, index: number) => {
          setTimeout(() => {
            document.location.href = link;
          }, index * 500);
        });
      }
    }
  }, [data, dispatch, id, token]);

  useEffect(() => {
    setContractTemplates(initialData?.contract_templates || []);

    setData({
      contract_template_id: initialData?.contract_template_id || null,
      issue_date: initialData?.issue_date
        ? changeMonthWitDate(initialData?.issue_date) : null,
      expiry_date: initialData?.expiry_date
        ? changeMonthWitDate(initialData?.expiry_date) : null,
    });
  }, [initialData]);

  useEffect(() => {
    if (initialData?.contract_templates) {
      setContractTemplates(initialData?.contract_templates);
    }
  }, [initialData?.contract_templates]);

  return {
    data,
    contractTemplates,
    setData,
    onClear,
    onSave,
  };
};
