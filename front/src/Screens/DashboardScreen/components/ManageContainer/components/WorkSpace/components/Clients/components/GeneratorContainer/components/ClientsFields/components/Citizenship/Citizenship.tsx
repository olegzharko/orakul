import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const Citizenship = () => (
  <div className="clients__citizenship">
    <SectionWithTitle title="Громадянство країни" onClear={() => console.log('clear')}>
      <div className="middle-column-fields">
        <div className="input-container">
          <CustomInput
            label="Громадянство"
            onChange={(e) => console.log(e)}
            value="Украинец"
          />
        </div>
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Citizenship;
