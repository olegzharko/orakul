import { useParams, useHistory } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { useMemo, useEffect, useState, useCallback } from 'react';

import { SelectItem } from '../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../store/types';
import reqManagerImmovables from '../../../../../../../../../../../../services/manager/Immovables/reqManagerImmovables';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';

import { MANAGE_CONTAINER_LINK_PREFIX } from '../../../../../../../../../../constants';

import { ManagerGeneralData } from './components/General/General';
import { ManagerResponsibleData } from './components/Responsible/Responsible';
import { ManagerContractData } from './components/Contract/Contract';
import { ManagerChecksData } from './components/Checks/Checks';

export const useImmovableFields = () => {
  const history = useHistory();
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { immovableId, clientId } = useParams<{clientId: string, immovableId: string}>();
  const [title, setTitle] = useState('');

  // Selects
  const [immovableTypes, setImmovableTypes] = useState<SelectItem[]>([]);
  const [buildings, setBuildings] = useState<SelectItem[]>([]);
  const [reader, setReader] = useState<SelectItem[]>([]);
  const [accompanying, setAccompanying] = useState<SelectItem[]>([]);
  const [contracts, setContracts] = useState<SelectItem[]>([]);
  const [checkList, setCheckList] = useState<ManagerChecksData>([]);

  // Fields Data
  const [general, setGeneral] = useState<ManagerGeneralData>({
    immovable_type_id: null,
    building_id: null,
    immovable_number: null,
    immovable_reg_num: null,
  });
  const [responsible, setResponsible] = useState<ManagerResponsibleData>({
    reader_id: null,
    accompanying_id: null,
  });
  const [contractType, setContractType] = useState<ManagerContractData>({
    contract_type_id: null,
  });
  const [checks, setChecks] = useState<any>();

  const isOnSaveDisabled = useMemo(() => !general.immovable_type_id
    || !general.building_id
    || !general.immovable_number,
  [general]);

  const onSave = useCallback(async () => {
    const bodyData = {
      ...general,
      ...responsible,
      ...contractType,
      ...checks,
    };

    if (token) {
      const res = await reqManagerImmovables(token, clientId, immovableId, 'PUT', bodyData);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );

      if (res?.success && immovableId === 'create') {
        history.push(`${MANAGE_CONTAINER_LINK_PREFIX}/immovables/${clientId}/${res?.data.immovable_id}`);
      }
    }
  }, [token, immovableId, general, responsible, contractType, checks]);

  useEffect(() => {
    if (token) {
      // get MANAGER_GENERAL
      (async () => {
        const res = await reqManagerImmovables(token, clientId, immovableId);

        if (res?.success) {
          setTitle(res?.data.title);

          setImmovableTypes(res?.data.immovable_type || []);
          setBuildings(res?.data.building || []);
          setGeneral({
            immovable_type_id: res?.data.immovable_type_id || '',
            building_id: res?.data.building_id || '',
            immovable_number: res?.data.immovable_number || '',
            immovable_reg_num: res?.data.immovable_reg_num || '',
          });

          setReader(res?.data.reader);
          setAccompanying(res?.data.accompanying);
          setResponsible({
            reader_id: res?.data.reader_id || null,
            accompanying_id: res?.data.accompanying_id || null,
          });

          setContracts(res?.data.contract_type);
          setContractType({ contract_type_id: res?.data.contract_type_id || null });

          setCheckList(res?.data.check_list || []);
          setChecks(res?.data.check_list.reduce((acc: any, item: any) => {
            acc[item.key] = item.value;
            return acc;
          }, {}));
        }
      })();
    }
  }, [token]);

  return {
    title,
    general,
    immovableTypes,
    buildings,
    reader,
    accompanying,
    responsible,
    contracts,
    contractType,
    checkList,
    checks,
    isOnSaveDisabled,
    setChecks,
    setContractType,
    setGeneral,
    setResponsible,
    onSave,
  };
};
