import { useSelector, useDispatch } from 'react-redux';
import { useState, useEffect, useCallback } from 'react';
import { useParams } from 'react-router-dom';
import reqGeneratorCityCreate from '../../../../../../../../../../../../../../../../services/generator/Client/AddNewCityModal/reqGeneratorCityCreate';
import { State } from '../../../../../../../../../../../../../../../../store/types';
import getGeneratorDistricts from '../../../../../../../../../../../../../../../../services/generator/Client/AddNewCityModal/getGeneratorDistricts';
import { setModalInfo } from '../../../../../../../../../../../../../../../../store/main/actions';

export type Props = {
  open: boolean;
  onClose: (value: boolean) => void;
};

export const useAddCityModal = ({ onClose }: Props) => {
  const dispatch = useDispatch();
  const { personId } = useParams<{personId: string}>();
  const { token } = useSelector((state: State) => state.main.user);

  const [region, setRegion] = useState([]);
  const [cityTypes, setCityTypes] = useState([]);
  const [districts, setDistricts] = useState([]);
  const [allData, setAllData] = useState({
    region_id: '',
    district_id: '',
    city_type_id: '',
    title: '',
  });

  const handleClose = useCallback(() => {
    onClose(false);
  }, []);

  const onClear = useCallback(() => {
    setAllData({
      region_id: '',
      district_id: '',
      city_type_id: '',
      title: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token && personId) {
      const res = await reqGeneratorCityCreate(token, 'POST', allData);

      if (res.success) {
        handleClose();
      }

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [allData, token, personId]);

  useEffect(() => {
    if (token && allData.region_id) {
      (async () => {
        const res = await getGeneratorDistricts(token, allData.region_id);

        if (res?.success) {
          setDistricts(res.data.district);
        }
      })();
    }
  }, [allData.region_id]);

  useEffect(() => {
    if (token && personId) {
      (async () => {
        const res = await reqGeneratorCityCreate(token);

        if (res?.success) {
          setRegion(res.data.regions);
          setCityTypes(res.data.city_type);
        }
      })();
    }
  }, [token, personId]);

  return {
    region,
    cityTypes,
    districts,
    allData,
    setAllData,
    onClear,
    onSave,
    handleClose,
  };
};
