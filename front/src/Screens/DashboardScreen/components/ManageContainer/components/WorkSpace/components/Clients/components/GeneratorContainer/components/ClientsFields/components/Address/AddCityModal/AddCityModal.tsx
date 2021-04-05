import React from 'react';
import './index.scss';
import Modal from '@material-ui/core/Modal';
import Backdrop from '@material-ui/core/Backdrop';
import Fade from '@material-ui/core/Fade';
import SectionWithTitle from '../../../../../../../../../../../../../../../components/SectionWithTitle';
import CustomSelect from '../../../../../../../../../../../../../../../components/CustomSelect';
import CustomInput from '../../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';

type Props = {
  open: boolean;
  onClose: (value: boolean) => void;
};

// eslint-disable-next-line prettier/prettier
const AddCityModal = ({ open, onClose }: Props) => {
  const handleClose = () => {
    onClose(false);
  };

  return (
    <Modal
      className="modal-container"
      open={open}
      onClose={handleClose}
      closeAfterTransition
      BackdropComponent={Backdrop}
      BackdropProps={{
        timeout: 500,
      }}
    >
      <Fade in={open}>
        <div className="add-city-modal">
          <SectionWithTitle title="Додати населений пункт" onClear={() => console.log('clear')}>
            <div className="add-city-modal__grid">
              <CustomSelect label="Область" data={[]} onChange={(e) => console.log(e)} />
              <CustomSelect label="Район" data={[]} onChange={(e) => console.log(e)} />
              <CustomSelect label="Тип населеного пункту" data={[]} onChange={(e) => console.log(e)} />
              <CustomInput label="Назва у НВ" onChange={(e) => console.log(e)} />
            </div>
          </SectionWithTitle>

          <div className="middle-button">
            <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
          </div>
        </div>
      </Fade>
    </Modal>
  );
};

export default AddCityModal;
