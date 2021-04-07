import React from 'react';
import './index.scss';
import Modal from '@material-ui/core/Modal';
import Backdrop from '@material-ui/core/Backdrop';
import Fade from '@material-ui/core/Fade';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';
import { useAddCityModal, Props } from './useAddCityModal';

// eslint-disable-next-line prettier/prettier
const AddCityModal = (props: Props) => {
  const meta = useAddCityModal(props);

  return (
    <Modal
      className="modal-container"
      open={props.open}
      onClose={meta.handleClose}
      closeAfterTransition
      BackdropComponent={Backdrop}
      BackdropProps={{
        timeout: 500,
      }}
    >
      <Fade in={props.open}>
        <div className="add-city-modal">
          <SectionWithTitle title="Додати населений пункт" onClear={meta.onClear}>
            <div className="add-city-modal__grid">
              <CustomSelect
                label="Область"
                data={meta.region}
                onChange={(e) => meta.setAllData({ ...meta.allData, region_id: e })}
                selectedValue={meta.allData.region_id}
              />
              <CustomSelect
                label="Район"
                data={meta.districts}
                onChange={(e) => meta.setAllData({ ...meta.allData, district_id: e })}
                selectedValue={meta.allData.district_id}
              />
              <CustomSelect
                label="Тип населеного пункту"
                data={meta.cityTypes}
                onChange={(e) => meta.setAllData({ ...meta.allData, city_type_id: e })}
                selectedValue={meta.allData.city_type_id}
              />
              <CustomInput
                label="Назва у НВ"
                onChange={(e) => meta.setAllData({ ...meta.allData, title: e })}
                value={meta.allData.title}
              />
            </div>
          </SectionWithTitle>

          <div className="middle-button">
            <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
          </div>
        </div>
      </Fade>
    </Modal>
  );
};

export default AddCityModal;
