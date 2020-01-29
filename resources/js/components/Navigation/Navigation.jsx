import React from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

import styled from './styled';

const Navigation = () => (
  <styled.Navigation>
    <styled.Link href="#">
      <FontAwesomeIcon icon="plus" />
    </styled.Link>
    <styled.Link href="#">
      <FontAwesomeIcon icon="cog" />
    </styled.Link>
  </styled.Navigation>
);

export default Navigation;
